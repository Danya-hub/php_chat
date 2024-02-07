import { APP_URL } from "../constants/paths.js";

class XHR {
  constructor(content_type) {
    this.xhr = new XMLHttpRequest();
    this.content_type = content_type;
  }

  open() {
    const [method, url, ...options] = arguments;

    this.xhr.open(method, `${APP_URL}/${url}`, true, ...options);
  }

  send(data) {
    if (this.content_type) {
      this.xhr.setRequestHeader("Content-type", this.content_type);
    }

    this.xhr.send(data);

    return new Promise((resolve, reject) => {
      this.xhr.onload = () => {
        if (this.xhr.readyState == XMLHttpRequest.DONE) {
          const response = JSON.parse(this.xhr.response);

          if (response.success) {
            resolve(response);
          } else {
            reject(response);
          }
        }
      };
    });
  }
}

export default XHR;
