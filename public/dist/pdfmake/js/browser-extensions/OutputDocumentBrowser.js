"use strict";

exports.__esModule = true;
exports.default = void 0;
var _OutputDocument = _interopRequireDefault(require("../OutputDocument"));
var _fileSaver = require("file-saver");
function _interopRequireDefault(e) { return e && e.__esModule ? e : { default: e }; }
/**
 * @returns {Window}
 */
const openWindow = () => {
  // we have to open the window immediately and store the reference
  // otherwise popup blockers will stop us
  let win = window.open('', '_blank');
  if (win === null) {
    throw new Error('Open PDF in new window blocked by browser');
  }
  return win;
};
class OutputDocumentBrowser extends _OutputDocument.default {
  /**
   * @returns {Promise<Blob>}
   */
  getBlob() {
    return new Promise((resolve, reject) => {
      this.getBuffer().then(buffer => {
        try {
          let blob = new Blob([buffer], {
            type: 'application/pdf'
          });
          resolve(blob);
        } catch (e) {
          reject(e);
        }
      }, result => {
        reject(result);
      });
    });
  }

  /**
   * @param {string} filename
   * @returns {Promise}
   */
  download(filename = 'file.pdf') {
    return new Promise((resolve, reject) => {
      this.getBlob().then(blob => {
        try {
          (0, _fileSaver.saveAs)(blob, filename);
          resolve();
        } catch (e) {
          reject(e);
        }
      }, result => {
        reject(result);
      });
    });
  }

  /**
   * @param {Window} win
   * @returns {Promise}
   */
  open(win = null) {
    return new Promise((resolve, reject) => {
      if (!win) {
        win = openWindow();
      }
      this.getBlob().then(blob => {
        try {
          let urlCreator = window.URL || window.webkitURL;
          let pdfUrl = urlCreator.createObjectURL(blob);
          win.location.href = pdfUrl;

          //
          resolve();
          /* temporarily disabled
          if (win === window) {
          	resolve();
          } else {
          	setTimeout(() => {
          		if (win.window === null) { // is closed by AdBlock
          			window.location.href = pdfUrl; // open in actual window
          		}
          		resolve();
          	}, 500);
          }
          */
        } catch (e) {
          win.close();
          reject(e);
        }
      }, result => {
        reject(result);
      });
    });
  }

  /**
   * @param {Window} win
   * @returns {Promise}
   */
  print(win = null) {
    return new Promise((resolve, reject) => {
      this.getStream().then(stream => {
        stream.setOpenActionAsPrint();
        return this.open(win).then(() => {
          resolve();
        }, result => {
          reject(result);
        });
      }, result => {
        reject(result);
      });
    });
  }
}
var _default = exports.default = OutputDocumentBrowser;