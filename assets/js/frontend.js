(function () {
	'use strict';

	function rahadOnReady(callback) {
		if (document.readyState === 'loading') {
			document.addEventListener('DOMContentLoaded', callback);
		} else {
			callback();
		}
	}

	function rahadGetDeviceFromWidth(width) {
		if (width <= 767) {
			return 'mobile';
		}
		if (width <= 1024) {
			return 'tablet';
		}
		return 'desktop';
	}

	function rahadApplyDeviceVisibility() {
		var width = window.innerWidth || document.documentElement.clientWidth;
		var currentDevice = rahadGetDeviceFromWidth(width);
		var nodes = document.querySelectorAll('[data-rahad-device-rule]');
		nodes.forEach(function (node) {
			var rule = node.getAttribute('data-rahad-device-rule');
			if (!rule || rule === 'all') {
				node.style.display = '';
				return;
			}
			if (rule !== currentDevice) {
				node.style.display = 'none';
			} else {
				node.style.display = '';
			}
		});
	}

	function rahadBindBackToTop() {
		document.querySelectorAll('[data-rahad-back-to-top="1"]').forEach(function (button) {
			button.addEventListener('click', function () {
				window.scrollTo({ top: 0, behavior: 'smooth' });
			});
		});
	}

	function rahadBindCountdowns() {
		var nodes = document.querySelectorAll('[data-rahad-countdown]');
		nodes.forEach(function (node) {
			var targetValue = node.getAttribute('data-rahad-countdown');
			if (!targetValue) {
				return;
			}
			var targetDate = new Date(targetValue);
			if (Number.isNaN(targetDate.getTime())) {
				return;
			}

			var daysNode = node.querySelector('[data-rahad-days]');
			var hoursNode = node.querySelector('[data-rahad-hours]');
			var minutesNode = node.querySelector('[data-rahad-minutes]');
			var secondsNode = node.querySelector('[data-rahad-seconds]');

			function update() {
				var now = new Date();
				var distance = targetDate.getTime() - now.getTime();
				if (distance < 0) {
					distance = 0;
				}

				var days = Math.floor(distance / (1000 * 60 * 60 * 24));
				var hours = Math.floor((distance / (1000 * 60 * 60)) % 24);
				var minutes = Math.floor((distance / (1000 * 60)) % 60);
				var seconds = Math.floor((distance / 1000) % 60);

				if (daysNode) {
					daysNode.textContent = String(days).padStart(2, '0');
				}
				if (hoursNode) {
					hoursNode.textContent = String(hours).padStart(2, '0');
				}
				if (minutesNode) {
					minutesNode.textContent = String(minutes).padStart(2, '0');
				}
				if (secondsNode) {
					secondsNode.textContent = String(seconds).padStart(2, '0');
				}
			}

			update();
			setInterval(update, 1000);
		});
	}

	function rahadBindImageComparison() {
		document.querySelectorAll('[data-rahad-comparison="1"]').forEach(function (widget) {
			var range = widget.querySelector('.rahad-comparison-range');
			var beforeWrap = widget.querySelector('.rahad-comparison-before-wrap');
			if (!range || !beforeWrap) {
				return;
			}
			range.addEventListener('input', function () {
				beforeWrap.style.width = String(range.value) + '%';
			});
		});
	}

	function rahadAnimationFromType(type) {
		switch (type) {
			case 'fade_down':
				return { y: -40, x: 0, scale: 1 };
			case 'slide_left':
				return { y: 0, x: 50, scale: 1 };
			case 'slide_right':
				return { y: 0, x: -50, scale: 1 };
			case 'zoom_in':
				return { y: 0, x: 0, scale: 0.75 };
			default:
				return { y: 40, x: 0, scale: 1 };
		}
	}

	function rahadRunAnimation(node) {
		if (!window.gsap) {
			node.style.opacity = '1';
			return;
		}

		var type = node.getAttribute('data-rahad-animation-type') || 'fade_up';
		var duration = parseFloat(node.getAttribute('data-rahad-animation-duration') || '0.8');
		var delay = parseFloat(node.getAttribute('data-rahad-animation-delay') || '0');
		var ease = node.getAttribute('data-rahad-animation-ease') || 'power2.out';
		var fromVars = rahadAnimationFromType(type);

		window.gsap.fromTo(
			node,
			{ autoAlpha: 0, x: fromVars.x, y: fromVars.y, scale: fromVars.scale },
			{ autoAlpha: 1, x: 0, y: 0, scale: 1, duration: duration, delay: delay, ease: ease }
		);
	}

	function rahadBindAnimations() {
		var animationNodes = document.querySelectorAll('[data-rahad-animation="1"]');
		if (!animationNodes.length) {
			return;
		}

		function runAll() {
			if ('IntersectionObserver' in window) {
				var observer = new IntersectionObserver(function (entries, ob) {
					entries.forEach(function (entry) {
						if (entry.isIntersecting) {
							rahadRunAnimation(entry.target);
							ob.unobserve(entry.target);
						}
					});
				}, { threshold: 0.15 });
				animationNodes.forEach(function (node) {
					observer.observe(node);
				});
			} else {
				animationNodes.forEach(rahadRunAnimation);
			}
		}

		if (window.gsap) {
			runAll();
			return;
		}

		if (
			typeof window.rahadFrontendData === 'object' &&
			window.rahadFrontendData.rahad_performance &&
			window.rahadFrontendData.rahad_performance.rahad_enable_gsap
		) {
			var script = document.createElement('script');
			script.src = window.rahadFrontendData.rahad_gsap_url;
			script.async = true;
			script.onload = runAll;
			document.head.appendChild(script);
		} else {
			runAll();
		}
	}

	rahadOnReady(function () {
		rahadApplyDeviceVisibility();
		rahadBindBackToTop();
		rahadBindCountdowns();
		rahadBindImageComparison();
		rahadBindAnimations();

		var resizeTimer;
		window.addEventListener('resize', function () {
			clearTimeout(resizeTimer);
			resizeTimer = setTimeout(rahadApplyDeviceVisibility, 120);
		});
	});
})();
