import tinycolor from 'tinycolor2'

function getColor(color, alpha = 1) {
    return tinycolor(color).setAlpha(alpha).toRgbString()
}

const labelColor = 'rgba(100,116,139,0.8)'

const borderColor = 'rgb(35,45,69)'

const gridDarkColor = 'rgba(100,116,139,0.3)'

const gridLightColor = 'rgb(203,213,225)'

const extractColor = (color, alpha) => getColor(getColorFromDom(color), alpha)

const getColorFromDom = (color) =>
    `rgb ${getComputedStyle(document.documentElement).getPropertyValue(`--color-${color}`)}`

export { getColor, labelColor, borderColor, gridDarkColor, gridLightColor, extractColor }
