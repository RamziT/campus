"use strict";

exports.__esModule = true;
exports.default = void 0;
var _variableType = require("./helpers/variableType");
function buildColumnWidths(columns, availableWidth, offsetTotal = 0, tableNode) {
  let autoColumns = [];
  let autoMin = 0;
  let autoMax = 0;
  let starColumns = [];
  let starMaxMin = 0;
  let starMaxMax = 0;
  let fixedColumns = [];
  let initial_availableWidth = availableWidth;
  columns.forEach(column => {
    if (isAutoColumn(column)) {
      autoColumns.push(column);
      autoMin += column._minWidth;
      autoMax += column._maxWidth;
    } else if (isStarColumn(column)) {
      starColumns.push(column);
      starMaxMin = Math.max(starMaxMin, column._minWidth);
      starMaxMax = Math.max(starMaxMax, column._maxWidth);
    } else {
      fixedColumns.push(column);
    }
  });
  fixedColumns.forEach((col, colIndex) => {
    // width specified as %
    if ((0, _variableType.isString)(col.width) && /\d+%/.test(col.width)) {
      // In tables we have to take into consideration the reserved width for paddings and borders
      let reservedWidth = 0;
      if (tableNode) {
        const paddingLeft = tableNode._layout.paddingLeft(colIndex, tableNode);
        const paddingRight = tableNode._layout.paddingRight(colIndex, tableNode);
        const borderLeft = tableNode._layout.vLineWidth(colIndex, tableNode);
        const borderRight = tableNode._layout.vLineWidth(colIndex + 1, tableNode);
        if (colIndex === 0) {
          // first column assumes whole borderLeft and half of border right
          reservedWidth = paddingLeft + paddingRight + borderLeft + borderRight / 2;
        } else if (colIndex === fixedColumns.length - 1) {
          // last column assumes whole borderRight and half of border left
          reservedWidth = paddingLeft + paddingRight + borderLeft / 2 + borderRight;
        } else {
          // Columns in the middle assume half of each border
          reservedWidth = paddingLeft + paddingRight + borderLeft / 2 + borderRight / 2;
        }
      }
      const totalAvailableWidth = initial_availableWidth + offsetTotal;
      col.width = parseFloat(col.width) * totalAvailableWidth / 100 - reservedWidth;
    }
    if (col.width < col._minWidth && col.elasticWidth) {
      col._calcWidth = col._minWidth;
    } else {
      col._calcWidth = col.width;
    }
    availableWidth -= col._calcWidth;
  });

  // http://www.freesoft.org/CIE/RFC/1942/18.htm
  // http://www.w3.org/TR/CSS2/tables.html#width-layout
  // http://dev.w3.org/csswg/css3-tables-algorithms/Overview.src.htm
  let minW = autoMin + starMaxMin * starColumns.length;
  let maxW = autoMax + starMaxMax * starColumns.length;
  if (minW >= availableWidth) {
    // case 1 - there's no way to fit all columns within available width
    // that's actually pretty bad situation with PDF as we have no horizontal scroll
    // no easy workaround (unless we decide, in the future, to split single words)
    // currently we simply use minWidths for all columns
    autoColumns.forEach(col => {
      col._calcWidth = col._minWidth;
    });
    starColumns.forEach(col => {
      col._calcWidth = starMaxMin; // starMaxMin already contains padding
    });
  } else {
    if (maxW < availableWidth) {
      // case 2 - we can fit rest of the table within available space
      autoColumns.forEach(col => {
        col._calcWidth = col._maxWidth;
        availableWidth -= col._calcWidth;
      });
    } else {
      // maxW is too large, but minW fits within available width
      let W = availableWidth - minW;
      let D = maxW - minW;
      autoColumns.forEach(col => {
        let d = col._maxWidth - col._minWidth;
        col._calcWidth = col._minWidth + d * W / D;
        availableWidth -= col._calcWidth;
      });
    }
    if (starColumns.length > 0) {
      let starSize = availableWidth / starColumns.length;
      starColumns.forEach(col => {
        col._calcWidth = starSize;
      });
    }
  }
}
function isAutoColumn(column) {
  return column.width === 'auto';
}
function isStarColumn(column) {
  return column.width === null || column.width === undefined || column.width === '*' || column.width === 'star';
}

//TODO: refactor and reuse in measureTable
function measureMinMax(columns) {
  let result = {
    min: 0,
    max: 0
  };
  let maxStar = {
    min: 0,
    max: 0
  };
  let starCount = 0;
  for (let i = 0, l = columns.length; i < l; i++) {
    let c = columns[i];
    if (isStarColumn(c)) {
      maxStar.min = Math.max(maxStar.min, c._minWidth);
      maxStar.max = Math.max(maxStar.max, c._maxWidth);
      starCount++;
    } else if (isAutoColumn(c)) {
      result.min += c._minWidth;
      result.max += c._maxWidth;
    } else {
      result.min += c.width !== undefined && c.width || c._minWidth;
      result.max += c.width !== undefined && c.width || c._maxWidth;
    }
  }
  if (starCount) {
    result.min += starCount * maxStar.min;
    result.max += starCount * maxStar.max;
  }
  return result;
}

/**
 * Calculates column widths
 */
var _default = exports.default = {
  buildColumnWidths: buildColumnWidths,
  measureMinMax: measureMinMax,
  isAutoColumn: isAutoColumn,
  isStarColumn: isStarColumn
};