let tableCollectionElements = document.getElementsByClassName('table-collection');

for (const tableCollectionElement of tableCollectionElements) {
    let title = tableCollectionElement.querySelector('h2');
    
    title.onclick = () => tableCollectionElement.classList.toggle('disabled');
}