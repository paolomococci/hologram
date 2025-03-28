import { Navbar } from "./Navbar"

/**
 *
 * Error: Binding element 'title' implicitly has an 'any' type.ts(7031)
 * To solve the above problem, it was enough to pass a default value.
 *
 * @param title
 * @returns
 */
function Header({ title = "" }) {
  return (
    <>
      <header className="navbar">
        <Navbar />
        <h3 className="mb-2 text-sm font-light text-purple-200 uppercase md:text-lg lg:text-xl">
          {title}
        </h3>
      </header>
    </>
  )
}

export default Header
