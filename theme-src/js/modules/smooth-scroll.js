/**
 * Smooth Scroll Component
 * Handles smooth scrolling for anchor links
 */
export class SmoothScroll {
  constructor() {
    this.init();
  }

  init() {
    // Add smooth scrolling to all anchor links that point to page sections
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', e => {
        const href = anchor.getAttribute('href');

        // Skip empty anchors or just "#"
        if (!href || href === '#') {
          return;
        }

        const target = document.querySelector(href);

        if (target) {
          e.preventDefault();

          // Calculate offset (useful for fixed headers)
          const headerHeight = this.getHeaderHeight();
          const targetPosition = target.offsetTop - headerHeight;

          // Smooth scroll to target
          window.scrollTo({
            top: targetPosition,
            behavior: 'smooth',
          });

          // Update URL without jumping
          if (history.pushState) {
            history.pushState(null, null, href);
          }

          // Focus the target for accessibility
          target.setAttribute('tabindex', '-1');
          target.focus();
        }
      });
    });
  }

  getHeaderHeight() {
    const header = document.querySelector('#masthead');
    return header ? header.offsetHeight : 0;
  }
}
