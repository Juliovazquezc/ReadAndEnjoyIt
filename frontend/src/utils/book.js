const getSkeletonBook = () => {
    return {
        name: '',
        author: '',
        publication_date: '',
        category : {
          id: null,
          name: '',
        }
    }
}

const formatBookToRequest = (book) => {
    const category_id = book.category.id;
    delete book.category;
    return {
        ...book,
        category_id
    };
}

export {
    getSkeletonBook,
    formatBookToRequest
}