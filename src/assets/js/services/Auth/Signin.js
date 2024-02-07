import Builder from "../../helpers/actionBuilder.js";
import XHR from "../../helpers/xhr.js";

class Signin extends Builder {
  constructor(error_message) {
    super();

    this.message_elem = error_message;
  }

  async login(payload) {
    document.body.classList.add("loading");

    try {
      const request = new XHR();
      request.open("POST", "login/page");

      const response = await request.send(payload);

      this.cases["login/succeeded"]?.call(this, response);
    } catch (error) {
      this.cases["login/failed"]?.call(this, error);
    }

    document.body.classList.remove("loading");
  }
}

export default Signin;
