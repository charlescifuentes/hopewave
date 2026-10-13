/**
 * Front-end JavaScript
 *
 * The JavaScript code you place here will be processed by esbuild. The output
 * file will be created at `../theme/js/script.min.js` and enqueued in
 * `../theme/functions.php`.
 *
 * For esbuild documentation, please see:
 * https://esbuild.github.io/
 */

/**
 * Header drawer: the dot-grid button opens the primary menu in a <dialog>.
 */
const drawer = document.getElementById('site-drawer');
const toggle = document.querySelector('.menu-toggle');

if (drawer && toggle) {
	const setExpanded = (expanded) =>
		toggle.setAttribute('aria-expanded', String(expanded));

	toggle.addEventListener('click', () => {
		drawer.showModal();
		setExpanded(true);
	});

	drawer
		.querySelector('.drawer-close')
		?.addEventListener('click', () => drawer.close());

	// Clicks on the backdrop land on the <dialog> itself, not its content.
	drawer.addEventListener('click', (event) => {
		if (event.target === drawer) {
			drawer.close();
		}
	});

	// Fires for the close button, backdrop clicks and the Escape key alike.
	drawer.addEventListener('close', () => {
		setExpanded(false);
		toggle.focus();
	});
}
