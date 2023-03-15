// const ViewPostImg = {
//   img: document.querySelector('.img-post-display'),
//   circle: document.querySelector('circle'),
//   circleAll: document.querySelectorAll('circle'),
//   nextimg() {
//     if (this.img.nextElementSibling != null) {
//       this.img.classList.add('hidden');
//       this.img.nextElementSibling.classList.remove('hidden');
//       this.img = this.img.nextElementSibling;

//       this.circle.setAttribute('fill', 'rgba(0,0,0,0.2)');
//       this.circle.nextElementSibling.setAttribute('fill', 'rgba(0,0,0,0.9)');
//       this.circle = this.circle.nextElementSibling;
//     }
//   },
//   previmg() {
//     if (this.img.previousElementSibling != null) {
//       this.img.classList.add('hidden');
//       this.img.previousElementSibling.classList.remove('hidden');
//       this.img = this.img.previousElementSibling;

//       this.circle.setAttribute('fill', 'rgba(0,0,0,0.2)');
//       this.circle.previousElementSibling.setAttribute('fill', 'rgba(0,0,0,0.9)');
//       this.circle = this.circle.previousElementSibling;
//     }
//   },
//   deleteEl(el) {
//     this.circleAll[el.getAttribute('circle')].remove();
//     el.remove();
//   },
// }

// Alpine.store('viewPostImg', ViewPostImg);

const ViewPostImg = {
  circle: function () { return document.createElementNS('http://www.w3.org/2000/svg', 'circle') },
  svg: function () { return document.createElementNS('http://www.w3.org/2000/svg', 'svg') },
  circleContainer: document.querySelector('.circle-container'),
  qtyImg: 0,
  init() {
    let active = document.querySelector('div[active]').getAttribute('active');
    let imgActive = document.querySelector(`#img${active}`);
    // imgActive.classList.remove('hidden');
    this.active ?? (this.active = active);
    // this.imgActive ?? (this.imgActive = imgActive);

    if (this.imgActive){
      imgActive.classList.remove('hidden');
      this.imgActive = imgActive;
    }

    this.slider();

    return active;
  },
  onload() {
    this.qtyImg += 1;
    Alpine.store('delay').delay(500, () => {
      let svg = this.editSvg();
      this.circleContainer.innerHTML = '';
      this.circleContainer.appendChild(svg);
    })
  },
  editSvg() {
    let active = this.active ?? null;
    let qtyCircle = 0;
    let svg = this.svg();

    for (let i = 0; i < this.qtyImg; i++) {
      qtyCircle += 1;
      let circle = this.circle();
      circle.setAttribute('fill', `rgba(0,0,0,${active == i ? 0.9 : 0.2})`);
      circle.setAttribute('stroke', 'none');
      circle.setAttribute('cy', '6.5');
      circle.setAttribute('cx', String(6 + (18 * qtyCircle)));
      circle.setAttribute('r', '6');
      svg.appendChild(circle);
    }

    svg.setAttribute('height', '13px');
    svg.setAttribute('width', String(12 + (18 * qtyCircle)));
    svg.setAttribute('viewBox', `0 0 ${12 + (18 * qtyCircle)} 13`);

    return svg;
  },

  getCircleActive() {
    let arr = [];
    document.querySelectorAll('.post-img-container > img').forEach(el => {
      arr.push(el.id);
    });
    let crcAct = document.querySelector(`circle:nth-child(${arr.indexOf(this.imgActive.id) + 1})`);
    // console.log('imgActive', arr.indexOf(this.imgActive.id));
    // console.log('crcAct', crcAct);
    this.circleActive = crcAct;
    // return crcAct;
  },

  nextimg() {
    // console.log(this.circleActive == undefined ? 'foo' : 'bar');
    this.circleActive ?? this.getCircleActive();
    if (this.imgActive.nextElementSibling != null) {
      this.imgActive.classList.add('hidden');
      this.imgActive.nextElementSibling.classList.remove('hidden');
      this.imgActive = this.imgActive.nextElementSibling;

      this.circleActive.setAttribute('fill', 'rgba(0,0,0,0.2)');
      this.circleActive.nextElementSibling.setAttribute('fill', 'rgba(0,0,0,0.9)');
      this.circleActive = this.circleActive.nextElementSibling;
      // console.log(this.circleActive);
    }
  },
  previmg() {
    this.circleActive ?? this.getCircleActive();
    if (this.imgActive.previousElementSibling != null) {
      this.imgActive.classList.add('hidden');
      this.imgActive.previousElementSibling.classList.remove('hidden');
      this.imgActive = this.imgActive.previousElementSibling;

      this.circleActive.setAttribute('fill', 'rgba(0,0,0,0.2)');
      this.circleActive.previousElementSibling.setAttribute('fill', 'rgba(0,0,0,0.9)');
      this.circleActive = this.circleActive.previousElementSibling;
    }
  },

  slider() {
    let imgContainer = document.querySelector('div[x-data=viewPostImg]');
    imgContainer.addEventListener('touchstart', (e) => {
      this.clientX = e.touches[0].clientX;
    });
    imgContainer.addEventListener('touchmove',(e) => {
      Alpine.store('delay').delay(50, () => {
        (e.touches[0].clientX - this.clientX) <= 50 ? this.nextimg() : this.previmg();
      });
    });
  }


}
// Alpine.store('viewPostImg', ViewPostImg);
Alpine.data('viewPostImg', () => (ViewPostImg));