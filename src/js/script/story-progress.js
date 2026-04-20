const progress = document.querySelector('.progress');
const progressBar = document.querySelector('.progress-bar');

window.onscroll = function () {
  updateScrollProgress();
};

function updateScrollProgress() {
  const postContent = document.querySelector('.post-content');

  if (!postContent) {
    return;
  }

  const viewportMid = window.innerHeight / 2;
  const rect = postContent.getBoundingClientRect();

  // Start is when the top of .post-content reaches the viewport midpoint.
  // End is when the bottom of .post-content reaches the viewport midpoint.
  const start = rect.top - viewportMid;
  const end = rect.bottom - viewportMid;
  const range = end - start;

  const scrolled = Math.min(100, Math.max(0, -start / range * 100));

  progress.setAttribute('aria-valuenow', scrolled);
  progressBar.setAttribute('style', `width: ${scrolled}%;`);
}
