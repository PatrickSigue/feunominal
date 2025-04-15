const rowone = document.querySelector('.rowone');
const banners = document.querySelectorAll('.rowone .banner-container');
const dots = document.querySelectorAll('.dot');

let index = 0;
let interval;

function updateBanner() {
  rowone.scrollTo({
    left: index * window.innerWidth,
    behavior: 'smooth'
  });
  dots.forEach(dot => dot.classList.remove('active'));
  dots[index].classList.add('active');
}

function startAutoScroll() {
  interval = setInterval(() => {
    index = (index + 1) % banners.length;
    updateBanner();
  }, 4000);
}

rowone.addEventListener('mouseover', () => clearInterval(interval));
rowone.addEventListener('mouseout', startAutoScroll);

dots.forEach(dot => {
  dot.addEventListener('click', () => {
    index = parseInt(dot.dataset.index);
    updateBanner();
  });
});

updateBanner();
startAutoScroll();