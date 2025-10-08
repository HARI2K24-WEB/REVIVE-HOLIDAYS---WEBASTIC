const slider = document.getElementById("slider");
const slides = document.querySelectorAll(".slide");
let current = 0;

document.getElementById("next").onclick = () => {
  current = (current + 1) % slides.length;
  slider.style.transform = `translateX(-${current * 100}%)`;
};
document.getElementById("prev").onclick = () => {
  current = (current - 1 + slides.length) % slides.length;
  slider.style.transform = `translateX(-${current * 100}%)`;
};
