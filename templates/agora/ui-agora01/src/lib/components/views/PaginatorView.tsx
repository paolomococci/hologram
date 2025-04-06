import { FC, useState } from "react"
import { useGetPaginatePostsQuery } from "../../services/posts-service.ts"
import ENV from "../../env/env.ts"
import { PostsPaginatorView } from "./PostsPaginatorView.tsx"

export const PaginatorView: FC = () => {
  const postsPerPage = ENV.postsPerPage
  // const page: number = 1
  const [page, setPage] = useState<number>(1)
  // const sieve: string = "alice"
  const [sieve, setSieve] = useState<string>("")

  // isFilteringFor: Am I filtering by title?
  // const [isFilteringFor, setIsFilteringFor] = useState<boolean>(false)

  const { data, error, isLoading } = useGetPaginatePostsQuery({
    page: page,
    sieve: sieve
  })

  console.log("Is Loading: ", isLoading)
  console.log("Error: ", error)
  console.log("Data posts: ", data?.posts)
  console.log("Page: ", page)
  console.log("Sieve: ", sieve)

  // total number of pages
  const totalNumberOfPages: number = data?.num
    ? Math.ceil(data?.num / postsPerPage)
    : 0

  /**
   * To navigate through the post pagination.
   *
   * @param pageNumber
   */
  const moveToPageNumber = (pageNumber: number) => {
    if (pageNumber >= 1 && pageNumber <= totalNumberOfPages) {
      setPage(pageNumber)
    }
    console.log("Current page from moveToPageNumber method: ", pageNumber)
  }

  return (
    <>
      {/* Posts view */}
      <PostsPaginatorView
        posts={data?.posts}
        // isFilteringFor={isFilteringFor}
      />

      {/* footer console */}
      <footer
        className="fixed right-0 left-0 bottom-0 card bg-stone-900"
        id="filter-posts"
      >
        <div className="fixed right-1 left-1 bottom-8">
          <button
            disabled={page === 1}
            onClick={() => {
              moveToPageNumber(page - 1)
              // setIsFilteringFor(true)
            }}
            id="prev"
            name="prev"
            className="p-1.5 my-1.5 mr-0.5 ml-1.5 bg-cyan-900 rounded-l-lg cursor-pointer disabled:cursor-not-allowed md:p-2 md:my-2 md:ml-2 lg:p-3.5 lg:my-3.5 lg:ml-3.5 text-slate-400"
          >
            prev
          </button>
          <input
            onBlur={(e) => {
              // setIsFilteringFor(true)
              setSieve(e.target.value)
              setPage(1)
            }}
            type="search"
            placeholder="search"
            id="filter"
            name="filter"
            className="p-1.5 text-center bg-cyan-900 disabled:cursor-not-allowed md:p-2 lg:p-3.5 text-slate-400"
          />
          <button
            disabled={page === totalNumberOfPages}
            onClick={() => {
              moveToPageNumber(page + 1)
              // setIsFilteringFor(true)
            }}
            id="next"
            name="next"
            className="p-1.5 my-1.5 mr-1.5 ml-0.5 bg-cyan-900 rounded-r-lg cursor-pointer disabled:cursor-not-allowed md:my-2 md:p-2 md:mr-2 lg:my-3.5 lg:p-3.5 lg:mr-3.5 text-slate-400"
          >
            next
          </button>
        </div>

        {/* Index over total number of pages */}
        <div className="fixed right-1 left-1 bottom-2">
          <output className="text-slate-400" hidden={!totalNumberOfPages}>
            {page} / {totalNumberOfPages}
          </output>
        </div>
      </footer>
    </>
  )
}
