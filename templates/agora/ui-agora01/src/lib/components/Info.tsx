import Header from './Header'

export const Info = () => {
    return (
        <>
            <header>
                <Header title="info" />
            </header>

            <main className="mt-3">
                <section id="info-content">
                    <article className="m-4">
                        <p className="p-2 prose md:prose-lg lg:prose-xl prose-stone">
                            This micro front end application allows you to read published and approved posts without
                            being able to apply any changes.
                        </p>
                        <p className="p-2 prose md:prose-lg lg:prose-xl prose-stone">
                            To read the posts you will need to go back to the home page and select the link that
                            leads to the posts.
                        </p>
                        <p className="p-2 prose md:prose-lg lg:prose-xl prose-stone">
                            Everything related to post creation, compliance and quality checks, publication,
                            accreditation, deprecation and any other administrative activity will be carried out
                            thanks to a graphical interface developed in the back-end of the application.
                        </p>
                        <p className="p-2 prose md:prose-lg lg:prose-xl prose-stone">Thank you.</p>
                    </article>
                </section>
            </main>
        </>
    )
}
