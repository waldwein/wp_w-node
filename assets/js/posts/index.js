document.addEventListener("DOMContentLoaded", () => {
  const exportButton = document.querySelector("#export-posts");
  let postsData = [];
  const allPost = new wp.api.collections.Posts();
  allPost.fetch().done((posts) => {
    const postsContainer = document.querySelector("#posts-wrapper");
    try {
      postsContainer.innerHTML = ""; // Clear previous posts
      postsData = posts.map((post) => {
        console.log(post);
        return {
          id: post.id,
          title: post.title.rendered,
          excerpt: post.excerpt.rendered,
          content: post.content.rendered,
          link: post.link,
          date: post.date,
          author: post.author,
          categories: post.categories,
          tags: post.tags,
        };
      });
    } catch (error) {
      console.log(error);
    }
    postsData.forEach((post) => {
      const postItem = document.createElement("tr");
      const date = new Date(post.date).toLocaleString();
      postItem.innerHTML = `

                <th scope="row" class="check-column">
                    <input id="cb-select-${post.id}" type="checkbox" class="post-checkbox" data-id="${post.id}">
                </th>
                <td class="title column-title has-row-actions column-primary page-title">
                    <strong>${post.title}</strong>
                </td>
                <td>${post.author}</td>
                <td>${post.categories.join(", ")}</td>
                <td>${post.tags.join(", ")}</td>
                <td class='date'>${date}</td>
              `;

      postsContainer.appendChild(postItem);
    });
    exportButton.style.display = "block"; // Show export button after loading posts
  });

  if (exportButton) {
    exportButton.addEventListener("click", () => {
      const selectedPosts = postsData.filter((post) => {
        const checkbox = document.querySelector(`.post-checkbox[data-id="${post.id}"]`);
        return checkbox && checkbox.checked;
      });
      fetch("http://localhost:3001/posts", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(selectedPosts),
      })
        .then((response) => response.json())
        .then((data) => {
          console.log("Success:", data);
          alert("Export successful!"); // Show success message

          // Reset checkboxes
          document.querySelectorAll(".post-checkbox").forEach((checkbox) => {
            checkbox.checked = false;
          });
        })
        .catch((error) => {
          console.error("Error:", error);
          alert("Export failed. Please try again."); // Show error message
        });
    });
  }
});
