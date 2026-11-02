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
 * Any other button controlling the drawer (such as the [hopewave_page_nav]
 * menu button on small screens) opens it too.
 */
const drawer = document.getElementById('site-drawer');
const toggles = document.querySelectorAll('[aria-controls="site-drawer"]');

if (drawer && toggles.length) {
	// The button that opened the drawer gets focus back when it closes.
	let opener = null;

	toggles.forEach((toggle) =>
		toggle.addEventListener('click', () => {
			opener = toggle;
			drawer.showModal();
			toggle.setAttribute('aria-expanded', 'true');
		})
	);

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
		opener?.setAttribute('aria-expanded', 'false');
		opener?.focus();
	});
}

/**
 * Footer "Our Courses" carousel: arrow buttons scroll the snap track one
 * slide at a time and wrap around at either end. Autoplay advances every
 * `data-autoplay` ms, pauses on hover/focus, stops for good once the visitor
 * uses the arrows or scrolls the track, and is skipped for reduced motion.
 */
document.querySelectorAll('.course-carousel').forEach((carousel) => {
	const track = carousel.querySelector('.carousel-track');
	if (!track || track.children.length < 2) {
		return;
	}

	const step = () => {
		const [first, second] = track.children;
		return second.offsetLeft - first.offsetLeft;
	};

	const go = (direction) => {
		const maxScroll = track.scrollWidth - track.clientWidth;
		const atEnd = track.scrollLeft >= maxScroll - 2;
		const atStart = track.scrollLeft <= 2;

		if (direction > 0 && atEnd) {
			track.scrollTo({ left: 0, behavior: 'smooth' });
		} else if (direction < 0 && atStart) {
			track.scrollTo({ left: maxScroll, behavior: 'smooth' });
		} else {
			track.scrollBy({ left: direction * step(), behavior: 'smooth' });
		}
	};

	let timer = null;
	let stopped = false;

	const stop = () => {
		clearInterval(timer);
		timer = null;
	};
	const start = () => {
		const delay = Number(carousel.dataset.autoplay);
		if (stopped || timer || !delay) {
			return;
		}
		timer = setInterval(() => go(1), delay);
	};
	const stopForGood = () => {
		stopped = true;
		stop();
	};

	carousel.querySelectorAll('.carousel-arrow').forEach((arrow) => {
		arrow.addEventListener('click', () => {
			stopForGood();
			go(Number(arrow.dataset.direction));
		});
	});

	track.addEventListener('keydown', (event) => {
		if (event.key === 'ArrowRight' || event.key === 'ArrowLeft') {
			event.preventDefault();
			stopForGood();
			go(event.key === 'ArrowRight' ? 1 : -1);
		}
	});
	track.addEventListener('wheel', stopForGood, { passive: true });
	track.addEventListener('touchstart', stopForGood, { passive: true });

	carousel.addEventListener('mouseenter', stop);
	carousel.addEventListener('mouseleave', start);
	carousel.addEventListener('focusin', stop);
	carousel.addEventListener('focusout', start);

	if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
		start();
	}
});
