"use strict";

import Builder from "../../helpers/actionBuilder.js";
import XHR from "../../helpers/xhr.js";

class Signup extends Builder {
  constructor(error_message) {
    super();

    this.error_message = error_message;
  }

  async createAccount(payload) {
    try {
      const request = new XHR();
      request.open("POST", "create_account/data");

      const response = await request.send(payload);

      this.cases["onCreatedAccount/succeeded"]?.call(this, response);
    } catch (error) {
      this.cases["onCreatedAccount/failed"]?.call(this, error);
    }
  }
}

export default Signup;
