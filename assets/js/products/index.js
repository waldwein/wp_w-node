document.addEventListener("DOMContentLoaded", () => {
  const consumerKey = "ck_82f258005d0ea81f114eb86166c944a43c8b72b6";
  const consumerSecret = "cs_110c3467452f31148c33eefa6f120c5e777582ca";
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
