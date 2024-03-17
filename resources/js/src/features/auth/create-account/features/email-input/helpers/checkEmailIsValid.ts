export const checkEmailIsValid = (email: string): boolean => {
    let pattern = new RegExp(/^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/)

    return pattern.test(email)
}
