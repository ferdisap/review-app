export const starRating = {
  run(container, value) {
    container.innerHTML = '';
    this.ratingValue(container, value);
  },
  ratingValue(container, value) {
    value = value / 2;
    value - 10 >= 0 ? this.createStar(container, 'orange') : (value - 10 >= -5 ? this.createStar(container, 'orange-to-black') : this.createStar(container, 'black'));
    value - 20 >= 0 ? this.createStar(container, 'orange') : (value - 20 >= -5 ? this.createStar(container, 'orange-to-black') : this.createStar(container, 'black'));
    value - 30 >= 0 ? this.createStar(container, 'orange') : (value - 30 >= -5 ? this.createStar(container, 'orange-to-black') : this.createStar(container, 'black'));
    value - 40 >= 0 ? this.createStar(container, 'orange') : (value - 40 >= -5 ? this.createStar(container, 'orange-to-black') : this.createStar(container, 'black'));
    value - 50 >= 0 ? this.createStar(container, 'orange') : (value - 50 >= -5 ? this.createStar(container, 'orange-to-black') : this.createStar(container, 'black'));
    container.nextElementSibling.innerHTML = value
  },
  createStar(container, color) {
    let el = document.createElement('span');
    el.classList.add('star', color);
    container.appendChild(el);
  }
}