import '../../App.css'
import AgoraLogo from './AgoraLogo'
import { Navbar } from './Navbar'

export const Landing = () => {

    return (
        <>
            <header className="navbar">
                <Navbar />
                {/* title */}
                <h1 className="text-sm font-light text-purple-600 uppercase md:text-xl lg:text-2xl">
                    agora
                </h1>
            </header>

            {/* main content */}
            <main className="m-2 card">
                <section className='flex justify-center items-center'>
                    <AgoraLogo />
                </section>
            </main>

            {/* footer */}
            <footer className="card" id="info-note">
                <div className="fixed right-1 left-1 bottom-2 justify-center items-center">
                    <p className="m-2 text-xs font-semibold text-purple-400 md:text-base lg:text-xl">
                        For changes to this view the first file to edit is almost always:{' '}
                        <code className="font-mono text-purple-300">src/lib/components/Landing.tsx</code>.
                    </p>
                </div>
            </footer>
        </>
    )
}
