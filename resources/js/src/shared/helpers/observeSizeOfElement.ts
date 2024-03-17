export function observeSize(element: HTMLElement, callback: () => void): () => void {
    const resizeObserver = new ResizeObserver(() => {
        callback()
    })
    resizeObserver.observe(element)
    return () => {
        resizeObserver.disconnect()
    }
}
