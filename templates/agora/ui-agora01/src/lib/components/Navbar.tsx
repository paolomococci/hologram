// import { Link } from 'react-router'
import { To } from './To'

export const Navbar = () => {
    const onSite = document.documentURI.split('/').pop()

    return (
        <>
            <nav className="flex justify-center items-center mt-2">
                <div className='grid grid-cols-3 gap-2 md:gap-4 lg:gap-8'>
                    <To path="/" inner="landing" onSite={onSite} />
                    <To path="/info" inner="info" onSite={onSite} />
                    <To path="/posts" inner="posts" onSite={onSite} />
                </div>
            </nav>
            <hr className='p-2 m-2' />
        </>
    )
}