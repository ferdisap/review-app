
<input type="range" id="rating" style="height: 5px;
        width:100px;">

<style>
  #rating {
    appearance: none;
    -webkit-appearance: none;
    background: linear-gradient(217deg, rgba(255,0,0,.8), rgba(255,0,0,0) 70.71%),
              linear-gradient(127deg, rgba(0,255,0,.8), rgba(0,255,0,0) 70.71%)
            ;
    height: 2px;
    padding: 0;
    outline: 1px solid transparent;
  }
  #rating::-webkit-slider-thumb {
    -webkit-appearance: none;
  }
  #rating:focus {
    outline: none; /* Removes the blue border. You should probably do some kind of focus styling for accessibility reasons though. */
  }
  #rating::-ms-track {
    width: 100%;
    cursor: pointer;

    /* Hides the slider so custom styles can be added */
    background: transparent; 
    border-color: transparent;
    color: transparent;
  }

  /* Special styling for WebKit/Blink */
  #rating::-webkit-slider-thumb {
    -webkit-appearance: none;
    border: 1px solid #000000;
    height: 10px;
    width: 1px;
    cursor: pointer;
  }
  /* All the same stuff for Firefox */
  #rating::-moz-range-thumb {
    border: 1px solid #000000;
    height: 10px;
    width: 1px;
    cursor: pointer;
  }
  /* All the same stuff for IE */
  #rating::-ms-thumb {
    border: 1px solid #000000;
    height: 1px;
    width: 1px;
    cursor: pointer;
  }

</style>
