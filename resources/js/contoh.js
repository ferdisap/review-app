const Obj1 = {
  name: 'Obj1',
  foo1(){
    console.log('Obj1, foo1');
    // console.log('Obj1, foo1 this', this);
  },
  addEvent(){
    document.addEventListener('keydown', this.foo1);
  },
  removeEvent(){
    document.removeEventListener('keydown', this.foo1);
  }
}

const Obj2 = {
  name: 'Obj2',
  foo2(){
    console.log('Obj2, foo2', this);
    // console.log('Obj2, foo2 this', this);
  },
  addEvent(){
    this.evt = this.foo2.bind(this);
    document.addEventListener('click', this.evt);

    // document.addEventListener('click', this.foo2);
  },
  removeEvent(){
    document.removeEventListener('click', this.evt);

    // document.removeEventListener('click', this.foo2);
  }
}
