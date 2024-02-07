"use strict";

import Builder from "../../helpers/actionBuilder.js";
import XHR from "../../helpers/xhr.js";

class VerifyEmail extends Builder {
  constructor(error_message) {
    super();

    this.error_message = error_message;
  }

  async checkCode(payload) {
    try {
      const request = new XHR();
      request.open("POST", "check_code/data");

      const response = await request.send(payload);
      this.cases["checkCode/succeeded"]?.call(this, response);
    } catch (error) {
      this.cases["checkCode/failure"]?.call(this, error);
    }
  }

  async sendCode(payload) {
    try {
      const request = new XHR();
      request.open("POST", "send_code/data");

      const response = await request.send(payload);
      this.cases["sendCode/succeeded"]?.call(this, response);
    } catch (error) {
      this.cases["sendCode/failure"]?.call(this, error);
    }
  }
}

export default VerifyEmail;
