<script>
  const handleClick = (event) => {
  const listTitle = event.target;
  const innerList = listTitle.nextElementSibling;
  const content = innerList.querySelector(".content");

  // listTitle.classList.toggle("active");
  if (listTitle.classList.contains("active")) {
    listTitle.classList.remove("active");
    innerList.style.height = 0;
  } else {
    listTitle.classList.add("active");
    innerList.style.height = `${content.clientHeight}px`;
  }
};

const listTitles = document.querySelectorAll(".list-title");
for (let listTitle of listTitles) {
  listTitle.addEventListener("click", handleClick);
}

</script>