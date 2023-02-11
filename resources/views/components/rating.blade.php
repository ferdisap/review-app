
@props(['ratingValue'])
<div class="flex justify-center items-end"
      x-data="{
        ratingValue: function(container, value){
          value = value/2;
          value - 10 >= 0 ? this.createStar(container, 'orange') : (value - 10 >= -5 ? this.createStar(container, 'orange-to-black') : this.createStar(container, 'black')) ;
          value - 20 >= 0 ? this.createStar(container, 'orange') : (value - 20 >= -5 ? this.createStar(container, 'orange-to-black') : this.createStar(container, 'black')) ;
          value - 30 >= 0 ? this.createStar(container, 'orange') : (value - 30 >= -5 ? this.createStar(container, 'orange-to-black') : this.createStar(container, 'black')) ;
          value - 40 >= 0 ? this.createStar(container, 'orange') : (value - 40 >= -5 ? this.createStar(container, 'orange-to-black') : this.createStar(container, 'black')) ;
          value - 50 >= 0 ? this.createStar(container, 'orange') : (value - 50 >= -5 ? this.createStar(container, 'orange-to-black') : this.createStar(container, 'black')) ;
        },
        createStar(container, color){
          let el = document.createElement('span');
          el.classList.add('star', color);
          container.appendChild(el);
        },
      }">
  <div x-init="ratingValue($el, {{ $ratingValue }})"></div>
  <p style="margin-top: 0;
        font-size:8px"
        >{{ $ratingValue }}</p>
</div>

