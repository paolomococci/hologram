import { Link } from 'react-router'

export const To = ({ path = "/", query = "", onSite = "", inner = "" }) => {
    const isOnSite: boolean = (path.split('/').pop() === onSite)
    const url: string = isOnSite ? "" : path
    // console.log(`path: ${path}, onSite: ${onSite}, isOnSite: ${isOnSite}`)

    if (!isOnSite) {
        return (
            <>
                <Link to={{ pathname: url, search: query }} className='m-1 text-sm uppercase md:m-2 lg:m-4 md:text-lg lg:text-xl'>
                    {inner}
                </Link>

            </>
        )
    } else {
        return (
            <>
                <a href="#" aria-disabled="true" className='m-1 text-sm uppercase md:m-2 lg:m-4 md:text-lg lg:text-xl anchor-disabled'>
                    {inner}
                </a>
            </>
        )
    }
}
