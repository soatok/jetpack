## Jetpack 12.9

### Before you start:

- **At any point during your testing, remember to [check your browser's JavaScript console](https://wordpress.org/support/article/using-your-browser-to-diagnose-javascript-errors/#step-3-diagnosis) and see if there are any errors reported by Jetpack there.**
- Use the "Debug Bar" or "Query Monitor" WordPress plugins to help make PHP notices and warnings more noticeable and report anything of note you see.

### AI Assistant

We have a new usage meter for the AI Assistant!

- Inside the editor, click the 'Jetpack' icon and open the 'AI Assistant' section.
- There should be a usage meter indicating how many requests you've used.
- Add/use an AI block and wait for it to process.
- The usage counter should increase - no page refresh needed.
- If you're not on an AI plan, a visual usage bar should be shown along with an 'Upgrade' button.
- Clicking the 'Upgrade' button should take you to the appropriate upgrade page.
- After completing the flow and purchasing the upgrade, you should no longer see the visual usage indicator or the upgrade button. Instead a message should be displayed about you having unlimited requests.

### Subscriptions

The subscriber pop-up is now available for self-hosted Jetpack sites.

- Go to "Jetpack > Settings > Newsletters" and enable the subscriber pop-up.
- Go to a frontend post without a paywall or limited access. Scroll and confirm the subscribe modal loads.
- You should be able to view the modal as either an admin, logged-in user or logged-out user.
- Once you dismiss the modal, it should not display again when visiting other posts or pages on the same site.

### Newsletters

Pre- and Post-publish newsletter panels have been updated to display newsletter categories and subscriber counts.

- Enable and select some Newsletter Categories for your test site (https://wordpress.com/settings/newsletter/). Make sure to save settings when you're done editing.
- On your test site, create a new post.
- Select only categories that are part of the Newsletter Categories.
- Click the publish button to display the pre-publish panel.
- The newsletter section should display a message about the post being sent to everyone in the selected newsletter categories.
- Go back and unselect all categories, and select one that's not a Newsletter Category.
- Click the publish button to display the pre-publish panel.
- The message will now read "The post will be sent to everyone subscribed to all content.".
- At the end of the message, you should also see a total subscriber count for everyone that will receive the post.

### VaultPress

VaultPress menu should be displayed when the product is active, even if the standalone plugin is not.

- Make sure the site has a VaultPress Backup plan.
- If you don't have the Jetpack VaultPress Backup plugin, you should see the VaultPress submenu (it should have a external link icon at the end).
- If you have the Jetpack VaultPress Backup plugin active, you should see VaultPress Backup submenu (without a external link icon).

### Blocks

The Blogroll block now allows listing non-WP.com sites.

- Add or edit a post.
- Add a "Blogroll (beta)" block.
- Click the "+" icon in the block.
- You should be able to add non WP.com entries to the Blogroll - like `google.com`.

The Subscribe block now has a setting for editing the input and button labels.

- Add or edit a post.
- Add a "Subscribe" block.
- Go to "Settings" section in the sidebar when the block is selected.
- It should contain inputs for editing the input placeholder and the button label.
- Typing in the input should affect the respective elements.

### And More!

You can see a [full list of changes in this release here](https://github.com/Automattic/jetpack-production/blob/trunk/CHANGELOG.md). Please feel free to test any and all functionality mentioned!

**Thank you for all your help!**
