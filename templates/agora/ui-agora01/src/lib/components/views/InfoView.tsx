import { FC } from "react"
import Header from "../Header"

export const InfoView: FC = () => {
  return (
    <>
      <header className="mb-2">
        <Header title="info" />
      </header>

      <main className="mt-24">
        <section id="info-content">
          <article className="m-8">
            <p className="prose md:prose-lg lg:prose-xl p-2 text-stone-300">
              This micro front end application allows you to read published and
              approved posts without being able to apply any changes.
            </p>
            <p className="prose md:prose-lg lg:prose-xl p-2 text-stone-300">
              To read the posts you will need to go back to the home page and
              select the link that leads to the posts.
            </p>
            <p className="prose md:prose-lg lg:prose-xl p-2 text-stone-300">
              Everything related to post creation, compliance and quality
              checks, publication, accreditation, deprecation and any other
              administrative activity will be carried out thanks to a graphical
              interface developed in the back-end of the application.
            </p>
            <p className="prose md:prose-lg lg:prose-xl p-2 text-stone-200">
              Thank you.
            </p>
          </article>
        </section>
      </main>
    </>
  )
}
