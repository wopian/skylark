// grab an element
var head = document.querySelector("header");
// construct an instance of Headroom, passing the element
var headroom = new Headroom(head, {
  "offset": 800,
  "tolerance": 5,
  "classes": {
    "initial": "animated",
    "pinned": "slideDown",
    "unpinned": "slideUp"
  }
});
headroom.init();

// to destroy
//headroom.destroy();
