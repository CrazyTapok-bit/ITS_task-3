export const timeZone = date => {
  const timezoneOffset = date.getTimezoneOffset() * 60000
  const dateWithTimezone = new Date(date.getTime() - timezoneOffset)
  return dateWithTimezone.toISOString().replace('T', ' ').slice(0, -5)
}
