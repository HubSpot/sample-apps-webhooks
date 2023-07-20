document.getElementById("copyBtn").onclick = async() => {
    let text = document.getElementById('redirectURL').textContent
    await navigator.clipboard.writeText(text)
    
    alert('Copied')
}
async function copyRedirectURL() {
    let field = document.createElement('input')
    field.value = document.getElementById('redirectURL').textContent
    let text = document.getElementById('redirectURL').textContent
    await navigator.clipboard.writeText(text)
    // document.body.appendChild(field)
    // field.select()
    
    // document.execCommand('copy')
    // document.body.removeChild(field)
    
    alert('Copied')
}
