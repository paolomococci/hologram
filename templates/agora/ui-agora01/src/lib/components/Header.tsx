import { Navbar } from "./Navbar"

/**
 * 
 * Error: Binding element 'title' implicitly has an 'any' type.ts(7031)
 * To solve the above problem, it was enough to pass a default value.
 * 
 * @param title
 * @returns 
 */
function Header({title = ""}) {
    return (
        <>
            <header>
                <Navbar />
                <h3 className="text-xs font-light text-purple-200 uppercase md:text-sm lg:text-lg">
                    {title}
                </h3>
            </header>
        </>
    )
}

export default Header
