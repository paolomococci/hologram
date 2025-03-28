import '../../../App.css'
import AgoraLogo from '../AgoraLogo'
import { Navbar } from '../Navbar'
import { Provider } from 'react-redux'
import { csrfCookieStore } from '../../stores/csrf-cookie-store.ts'
import { CsrfCookieConsole } from '../console/CsrfCookieConsole.tsx'

export const LandingView = () => {

    return (
        <>
            <Provider store={csrfCookieStore}>
                <CsrfCookieConsole />
            </Provider>
            <header className="navbar mb-2">
                <Navbar />
                {/* title */}
                <h1 className="mb-2 text-sm font-light text-purple-600 uppercase md:text-xl lg:text-2xl">
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
                        <code className="font-mono text-purple-300">src/lib/components/views/LandingView.tsx</code>.
                    </p>
                </div>
            </footer>
        </>
    )
}
