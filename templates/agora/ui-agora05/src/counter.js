export function setupCounter(
  elementButton,
  elementOutput
) {
  let counter = 0
  const setCounter = (count) => {
    counter = count
    elementOutput.innerHTML = `${counter}`
  }
  elementButton.addEventListener('click', () => setCounter(counter + 1))
  setCounter(0)
}
