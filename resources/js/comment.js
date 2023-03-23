const CommentDua = {
  /**
   * open / close table review
   */
  open: JSON.parse(document.querySelector('div[open_comment_form]').getAttribute('open_comment_form')),

  /**
   * open / close add comment form
   */
  open_add_comment_form: JSON.parse(document.querySelector('div[open_add_comment_form]').getAttribute('open_add_comment_form')),

  /**
   * 
   * @returns string berupa template
   */
  load_view()
  {
    return fetch('/load_view').then(rsp => rsp.json()).then(rst => rst.view);
  },

  /**
   * Untuk mendapatkan string template berupa :regex_XXXXX: di dalam template; 
   * xxx adalah >> comment.data.xxx
   * data itu berbentuk array
   * @param {string} str 
   * @returns 
   */
  getStringSlot(str) {
    const regex = /(?<=:regex_)[a-zA-Z0-9._]+(?=:)/gm;
    let arr = [];
    let m;
    while ((m = regex.exec(str)) !== null) {            
      if (m.index === regex.lastIndex) {
          regex.lastIndex++;
      }
      arr.push(m[0]);
    }
    return arr;
  },

  /**
   * Set value template yang isinya :regex_XXXXX:
   * @param {string} str berupa template html
   * @param {string} subst berupa string penegganti untuk slotName
   * @param {string} slotName berupa data comment seperti uuid, author, dll
   * @returns 
   */
  setStringSlot(str, subst, slotName) {
    const regex = eval(`/:regex_${slotName}:/g`);
    return str.replace(regex, subst);
  },

  /**
   * limit for comment query data
   */
  limit: parseInt(document.querySelector('div[limit]').getAttribute('limit')),

  /**
   * offset for comment query data
   */
  offset: 0,

  /**
   * send, receive, further action in getting comment from backend 
   * @param {string} post_uuid 
   */
  async more_comment(post_uuid, needSession = true) {
    // get the view from backend if not already available
    if (this.comment_view_template == undefined) {
      this.comment_view_template = await this.load_view();
    }

    // getting/receiving comment from backend
    fetch(`/more_comment?post_uuid=${post_uuid}&limit=${this.limit}&offset=${this.offset}`)
      .then(rsp => rsp.json())
      .then(rst => {
        if(needSession){
          if (rst.comments.length == 0){
            Alpine.store('session').push(rst.status, rst.message);
          }
        }
        rst.comments.forEach(comment => {
          let template = this.comment_view_template;
          let strSlots = this.getStringSlot(template);
          let div = document.createElement('div');

          // fill the slot with the slotString, ex: :regex_XXX: to be :YYY:
          strSlots.forEach(slotName => {
            template = this.setStringSlot(template, eval(`comment.${slotName}`), slotName);
          });

          // prepare the template to prepend into comment container 
          div.innerHTML = template;

          // set the after comment action (report/delete/edit)
          if (comment.is_mine) {
            div.querySelector('.delete').classList.remove('hidden');
            div.querySelector('.edit').classList.remove('hidden');
            div.querySelector('.report').remove();
          } else {
            div.querySelector('.delete').remove();
            div.querySelector('.edit').remove();
            div.querySelector('.report').classList.remove('hidden');
          }

          // append the comment into container by using prepend so the latest update comment is the first one
          document.querySelector('.comment-container').prepend(div);
        });

        // setting this offset/limit property after the comment appended
        this.offset += rst.comments.length;
        this.limit = 2;

        // set input [name=qtyComment] untuk keperluan oldInput nanti
        document.querySelector('input[name=qtyComment]').value = this.offset;
      });
  },

  /**
   * delete the comment, 
   * (in backend: if the user is authenticated, proceed)
   * (in backend: if the comment is his own, proceed)
   */
  delete_comment(comment_uuid){
    let url = `/comment/${comment_uuid}/delete`
  }
}

Alpine.data('comment', () => (CommentDua));