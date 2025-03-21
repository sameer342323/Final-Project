const leftArrow = document.getElementById('left');
const rightArrow = document.getElementById('right');
const slider = document.getElementById('slider');
let slideNumber = 1;
const images = document.querySelectorAll('.img');
const length = images.length;
let slideWidth = 1000;
const nextSlide = () => {
  slider.style.transform = `translateX(-${slideNumber * slideWidth}px)`;
  slideNumber++;
};
const previousSlide = () => {
  slider.style.transform = `translateX(-${(slideNumber - 1) * slideWidth}px)`;
  slideNumber--;
};
const getFirstSlide = () => {
  slider.style.transform = `translateX(0px)`;
  slideNumber = 1;
};

const getLastSlide = () => {
  slider.style.transform = `translateX(-${(length - 1) * slideWidth}px)`;
  slideNumber = length;
};
rightArrow.addEventListener('click', () => {
  if (slideNumber < length) {
    nextSlide();
  } else {
    getFirstSlide();
  }
});

leftArrow.addEventListener('click', () => {
  if (slideNumber > 1) {
    previousSlide();
  } else {
    getLastSlide();
  }
});