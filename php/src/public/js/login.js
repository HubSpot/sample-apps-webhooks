function copyRedirectURL() {
    let field = document.createElement('input')
    field.value = document.getElementById('redirectURL').textContent
    
    document.body.appendChild(field)
    field.select()
    
    document.execCommand('copy')
    document.body.removeChild(field)
    
    alert('Copied')
}
