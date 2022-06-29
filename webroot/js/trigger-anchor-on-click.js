/**
 * @type {NodeListOf<HTMLElementTagNameMap["button"]>}
 */
const buttons = document.querySelectorAll("button");

for (const button of buttons) {
  const anchorElement = button.querySelector("a");

  if (anchorElement !== undefined) {
    button.addEventListener("click", () => {
      anchorElement.click();
    })
  }
}

/**
 * @type {NodeListOf<HTMLElementTagNameMap["li"]>}
 */
const lists = document.querySelectorAll("li");
for (const list of lists) {
  const anchorElement = list.querySelector("a");

  if (anchorElement !== undefined) {
    list.addEventListener("click", () => {
      anchorElement.click();
    })
  }
}