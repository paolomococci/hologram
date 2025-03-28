// import { Link } from 'react-router'
import { To } from './To'

export const Navbar = () => {
    const onSite = document.documentURI.split('/').pop()

    return (
        <>
            <nav className="mt-2 flex justify-center items-center">
                <To path="/" inner="landing" onSite={onSite} />
                <To path="/info" inner="info" onSite={onSite} />
                <To path="/posts" inner="posts" onSite={onSite} />
            </nav>
            <hr className='m-2 p-2' />
        </>
    )
}