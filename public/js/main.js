const articlesTable = document.getElementById('articles_table');

if (articlesTable) {
  articlesTable.addEventListener('click', e => {
    if (e.target.className === "btn btn-danger delete-article me-1") {
      if (confirm('Are you sure?')) {
        const id = e.target.getAttribute('data-id');

        fetch(`/article/${id}/delete`, {
          method: 'DELETE'
        })
          .then(res => {
            if (res.status === 200) {
              window.location.reload()
            } else {
              alert(res.statusText)
            }

          })


      }
    }
  })
}