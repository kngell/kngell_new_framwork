export default class StripeAPIClient {
  constructor(params = {}) {
    this.api_key = params.api_key; // ok
    this.cardHolderFname = params.cardHolderFname; //ok
    this.cardHolderLname = params.cardHolderLname; //ok
    this.cardElement = params.cardElement; //ok
    this.cardError = params.cardError; //ok
    this.cardErrorID = params.cardErrorID;
    this.cardButton = params.cardButton; //ok
    this.cardButtonID = params.cardButtonID;
    this.responseError = params.responseError; //ok
  }
  /**
   * Manage Button
   * ======================================================================================
   */
  _create_cardElements = () => {
    const plugin = this;
    // document.querySelector(plugin.cardButtonID).disabled = true;
    let stripe = Stripe(plugin.api_key);
    var style = {
      base: {
        color: "#32325d",
        fontFamily: "Arial, sans-serif",
        fontSmoothing: "antialiased",
        fontSize: "16px",
        "::placeholder": {
          color: "#32325d",
        },
      },
      invalid: {
        fontFamily: "Arial, sans-serif",
        color: "#fa755a",
        iconColor: "#fa755a",
      },
    };
    let elements = stripe.elements();
    let card = elements.create("card", { style: style });
    card.mount(plugin.cardElement);
    card.on("change", function (event) {
      // Disable the Pay button if there are no card details in the Element
      document.querySelector(plugin.cardButtonID).disabled = event.empty;
      document.querySelector(plugin.cardErrorID).textContent = event.error
        ? event.error.message
        : "";
    });
    plugin._manage_errors(card);
    plugin.card = card;
    plugin.stripe = stripe;
    return plugin;
  };

  /**
   * Manage Errors
   * ======================================================================================
   */
  _manage_errors = (card) => {
    const plugin = this;
    card.addEventListener("change", (e) => {
      if (e.error) {
        plugin.cardError.textContent = e.error.message;
      } else {
        plugin.cardError.textContent = "";
      }
    });
  };
  /**
   * Create Paiment
   * ======================================================================================
   */
  _createPayment = () => {
    const plugin = this;
    return new Promise((resolve, reject) => {
      plugin.stripe
        .createPaymentMethod({
          type: "card",
          card: plugin.card,
          billing_details: {
            // Include any additional collected billing details.
            name:
              plugin.cardHolderFname.value + " " + plugin.cardHolderLname.value,
          },
        })
        .then((response) => {
          if (response.error) {
            reject(response);
          } else {
            resolve(response);
          }
        });
    });
  };
}
