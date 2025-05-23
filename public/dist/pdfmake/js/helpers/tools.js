"use strict";

exports.__esModule = true;
exports.convertToDynamicContent = convertToDynamicContent;
exports.offsetVector = offsetVector;
exports.pack = pack;
function pack(...args) {
  let result = {};
  for (let i = 0, l = args.length; i < l; i++) {
    let obj = args[i];
    if (obj) {
      for (let key in obj) {
        if (obj.hasOwnProperty(key)) {
          result[key] = obj[key];
        }
      }
    }
  }
  return result;
}
function offsetVector(vector, x, y) {
  switch (vector.type) {
    case 'ellipse':
    case 'rect':
      vector.x += x;
      vector.y += y;
      break;
    case 'line':
      vector.x1 += x;
      vector.x2 += x;
      vector.y1 += y;
      vector.y2 += y;
      break;
    case 'polyline':
      for (let i = 0, l = vector.points.length; i < l; i++) {
        vector.points[i].x += x;
        vector.points[i].y += y;
      }
      break;
  }
}
function convertToDynamicContent(staticContent) {
  return () =>
  // copy to new object
  JSON.parse(JSON.stringify(staticContent));
}