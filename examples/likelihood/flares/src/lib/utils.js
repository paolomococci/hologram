export const timeSpentOn = (beginTime, endTime) => {
    const timeElapsed = endTime - beginTime
    if (timeElapsed < 1000) {
        return `Done in ${timeElapsed}ms`
    } else if (timeElapsed < 60000) {
        const seconds = Math.trunc((timeElapsed % 60000) / 1000)
        return `Done in ${seconds}s`
    } else if (timeElapsed < 3600000) {
        const seconds = Math.trunc((timeElapsed % 60000) / 1000)
        const minutes = Math.trunc(timeElapsed / 60000)
        return `Done in ${minutes}m and ${seconds}s`
    } else {
        const timeElapsedInSeconds = timeElapsed / 1000
        const timeElapsedInMinutes = Math.trunc(timeElapsedInSeconds / 60)
        const minutes = timeElapsedInMinutes % 60
        const hours = Math.trunc(timeElapsedInMinutes / 60)
        return `Done in ${hours}h and ${minutes}m`
    }
}
