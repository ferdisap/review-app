const ViewPostImg = {
  img: document.querySelector('.img-post-display'),
  circle: document.querySelector('circle'),
  circleAll: document.querySelectorAll('circle'),
  nextimg() {
    if (this.img.nextElementSibling != null) {
      this.img.classList.add('hidden');
      this.img.nextElementSibling.classList.remove('hidden');
      this.img = this.img.nextElementSibling;

      this.circle.setAttribute('fill', 'rgba(0,0,0,0.2)');
      this.circle.nextElementSibling.setAttribute('fill', 'rgba(0,0,0,0.9)');
      this.circle = this.circle.nextElementSibling;
    }
  },
  previmg() {
    if (this.img.previousElementSibling != null) {
      this.img.classList.add('hidden');
      this.img.previousElementSibling.classList.remove('hidden');
      this.img = this.img.previousElementSibling;

      this.circle.setAttribute('fill', 'rgba(0,0,0,0.2)');
      this.circle.previousElementSibling.setAttribute('fill', 'rgba(0,0,0,0.9)');
      this.circle = this.circle.previousElementSibling;
    }
  },
  deleteEl(el) {
    this.circleAll[el.getAttribute('circle')].remove();
    el.remove();
  },
}

Alpine.store('viewPostImg', ViewPostImg);