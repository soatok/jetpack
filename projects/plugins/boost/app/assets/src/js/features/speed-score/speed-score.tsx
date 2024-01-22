import {
	getScoreLetter,
	didScoresChange,
	getScoreMovementPercentage,
} from '@automattic/jetpack-boost-score-api';
import { BoostScoreBar, Button } from '@automattic/jetpack-components';
import { sprintf, __ } from '@wordpress/i18n';
import ContextTooltip from './context-tooltip/context-tooltip';
import RefreshIcon from '$svg/refresh';
import PopOut from './pop-out/pop-out';
import PerformanceHistory from '$features/performance-history/performance-history';
import ErrorNotice from '$features/error-notice/error-notice';
import classNames from 'classnames';
import { useEffect, useMemo } from 'react';
import { useDebouncedRefreshScore, useSpeedScores } from './lib/hooks';

import styles from './speed-score.module.scss';
import { useModulesState } from '$features/module/lib/stores';
import { useCriticalCssState } from '$features/critical-css/lib/stores/critical-css-state';
import { useLocalCriticalCssGeneratorStatus } from '$features/critical-css/local-generator/local-generator-provider';

const SpeedScore = () => {
	const { site } = Jetpack_Boost;
	const [ { status, error, scores }, loadScore ] = useSpeedScores( site.url );
	const scoreLetter = scores ? getScoreLetter( scores.current.mobile, scores.current.desktop ) : '';
	const showPrevScores = scores && didScoresChange( scores ) && ! scores.isStale;
	const [ { data } ] = useModulesState();
	const [ cssState ] = useCriticalCssState();
	const { isGenerating: criticalCssIsGenerating } = useLocalCriticalCssGeneratorStatus();

	// Construct an array of current module states
	const moduleStates = useMemo(
		() =>
			Object.entries( data || {} ).reduce( ( acc: boolean[], [ key, value ] ) => {
				if ( key !== 'image_guide' && key !== 'image_size_analysis' ) {
					acc.push( value.active );
				}
				return acc;
			}, [] ),
		[ data ]
	);

	const showScoreChangePopOut =
		status === 'loaded' && ! scores.isStale && getScoreMovementPercentage( scores );

	// Always load the score on mount.
	useEffect( () => {
		if ( site.online ) {
			loadScore();
		}
	}, [ loadScore, site.online ] );

	useDebouncedRefreshScore(
		{ moduleStates, criticalCssCreated: cssState.created || 0, criticalCssIsGenerating },
		async () => {
			if ( site.online ) {
				await loadScore( true ); // Force a refresh.
			}
		}
	);

	// translators: %s is a letter grade, e.g. "A" or "B"
	let heading = sprintf( __( 'Overall Score: %s', 'jetpack-boost' ), scoreLetter );
	if ( status === 'loading' ) {
		heading = __( 'Loading…', 'jetpack-boost' );
	} else if ( status === 'error' ) {
		heading = __( 'Whoops, something went wrong', 'jetpack-boost' );
	}

	return (
		<>
			<div className="jb-container">
				<div id="jp-admin-notices" className="jetpack-boost-jitm-card" />
				<div
					data-testid="speed-scores"
					className={ classNames( styles[ 'speed-scores' ], { loading: status === 'loading' } ) }
				>
					{ site.online ? (
						<div className={ styles.top } data-testid="speed-scores-top">
							<h2>{ heading }</h2>
							{ status === 'loaded' && <ContextTooltip /> }
							<Button
								variant="link"
								size="small"
								weight="regular"
								className={ styles[ 'action-button' ] }
								onClick={ () => loadScore( true ) }
								disabled={ status === 'loading' }
								icon={ <RefreshIcon /> }
							>
								{ __( 'Refresh', 'jetpack-boost' ) }
							</Button>
						</div>
					) : (
						<div className={ styles.offline } data-testid="speed-scores-offline">
							<h2>{ __( 'Website Offline', 'jetpack-boost' ) }</h2>
							<p>
								{ __(
									'All Jetpack Boost features are still available, but to get a performance score you would first have to make your website available online.',
									'jetpack-boost'
								) }
							</p>
						</div>
					) }

					{ status === 'error' && (
						<ErrorNotice
							title={ __( 'Failed to load Speed Scores', 'jetpack-boost' ) }
							error={ error }
							suggestion={ __( '<action>Try again</action>', 'jetpack-boost' ) }
							vars={ {
								action: <Button size="small" variant="link" onClick={ () => loadScore( true ) } />,
							} }
						/>
					) }

					<BoostScoreBar
						prevScore={ scores.noBoost?.mobile }
						score={ scores.current.mobile }
						active={ site.online }
						isLoading={ status === 'loading' }
						showPrevScores={ showPrevScores }
						scoreBarType="mobile"
						noBoostScoreTooltip={ __( 'Your mobile score without Boost', 'jetpack-boost' ) }
					/>

					<BoostScoreBar
						prevScore={ scores.noBoost?.desktop }
						score={ scores.current.desktop }
						active={ site.online }
						isLoading={ status === 'loading' }
						showPrevScores={ showPrevScores }
						scoreBarType="desktop"
						noBoostScoreTooltip={ __( 'Your desktop score without Boost', 'jetpack-boost' ) }
					/>
				</div>
				{ site.online && <PerformanceHistory /> }
			</div>

			<PopOut scoreChange={ showScoreChangePopOut } />
		</>
	);
};

export default SpeedScore;
