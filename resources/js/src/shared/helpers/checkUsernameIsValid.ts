export const checkUsernameIsValid = (username: string): boolean => {
    let pattern = new RegExp(/^[a-zA-Z0-9]+$/)

    return pattern.test(username)
}
