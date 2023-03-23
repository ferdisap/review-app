export const delay = {
  delay(t, callback) {
    clearTimeout(this.to);
    this.to = setTimeout(callback, t);
  }
}