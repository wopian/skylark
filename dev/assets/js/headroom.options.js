// grab an element
var myElement = document.querySelector("header");
// construct an instance of Headroom, passing the element
var headroom  = new Headroom(myElement, {
  "offset": 800,
  "tolerance": 5,
  "classes": {
    "initial": "animated",
    "pinned": "headroom--pinned",
    "unpinned": "headroom--unpinned"
  }
});
// initialise
headroom.init();
