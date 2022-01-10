let r = document.querySelector(':root');
let hueColor = getComputedStyle(r).getPropertyValue('--hueColor');
let mainColor = `hsl(${hueColor}, 100%, 50%)`;