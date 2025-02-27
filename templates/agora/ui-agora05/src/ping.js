export async function setupPing(
    uriCookie,
    uriApi,
    elementOutput
) {

    // retrieve sanctum/csrf-cookie
    // let jsonResCookie = null
    const responseCookie = await fetch(uriCookie)
    if (!responseCookie.ok) {
        throw new Error(`Response status: ${responseCookie.status}`)
        // console.error(`Response status: ${responseCookie.status}`)
    } else {
        try {
            // jsonResCookie = await responseCookie.json()
            // console.log(jsonResCookie)
        } catch (error) {
            console.error(error)
        }
    }

    // retrieve api/ping
    let jsonResApi = null
    const responseApi = await fetch(uriApi)
    if (!responseApi.ok) {
        throw new Error(`Response status: ${responseApi.status}`)
        // console.error(`Response status: ${responseApi.status}`)
    } else {
        try {
            jsonResApi = await responseApi.json()
            console.log(jsonResApi)
        } catch (error) {
            console.error(error)
        }
    }

    elementOutput.innerHTML = (jsonResApi === null) ? 'No data to return!' : `${jsonResApi.message}`
}
