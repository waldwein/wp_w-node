document.addEventListener("DOMContentLoaded", () => {
  const consumerKey = "ck_44631ccca9fcdd17de04c6bfd4d8cd258dc543b9";
  const consumerSecret = "cs_5c6032ffa842edbc67de9371e1cd1503f0c2e682";
  const url = "http://localhost/wordpress/wp-json/wc/v3/products";
  fetch(url, {
    method: "GET",
    headers: {
      Authorization: "Basic " + btoa(consumerKey + ":" + consumerSecret),
    },
  })
    .then((response) => response.json())
    .then((data) => {
      console.log(data); // This will log the products in JSON format
    })
    .catch((error) => console.error("Error:", error));
});
