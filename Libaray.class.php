<?php
class Book
{
    public $title;
    public $author;

    public function __construct($title, $author)
    {
        $this->title = $title;
        $this->author = $author;
    }
}

class Section
{
    public $name;
    public $books = [];

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function addBook($book)
    {
        $this->books[] = $book;
    }

    public function countBooks()
    {
        return count($this->books);
    }
}

class Customer
{
    public $name;
    public $purchasedBooks = [];

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function buyBook($book, $library)
    {
        // Check if the book is available in any section of the library.
        foreach ($library->sections as $section) {
            if (in_array($book, $section->books)) {
                // Add the book to the customer's purchased books.
                $this->purchasedBooks[] = $book;

                // Remove the book from the library's section.
                $key = array_search($book, $section->books);
                if ($key !== false) {
                    unset($section->books[$key]);
                }

                echo "{$this->name} has purchased '{$book->title}' by {$book->author} from the {$section->name} section.\n";
                return; // Exit the loop once the book is found and purchased.
            }
        }

        // If the loop completes without finding the book, it's not available in the library.
        echo "Sorry, '{$book->title}' by {$book->author} is not available in any section of the library.\n";
    }
}

class Library
{
    public $sections = [];

    public function addSection($section)
    {
        $this->sections[] = $section;
    }

    public function countTotalBooks()
    {
        $totalCount = 0;
        foreach ($this->sections as $section) {
            $totalCount += $section->countBooks();
        }
        return $totalCount;
    }
}

// Usage example:
$library = new Library();

$fictionSection = new Section("Fiction");
$fictionSection->addBook(new Book("Book 1", "Author 1"));
$fictionSection->addBook(new Book("Book 2", "Author 2"));

$nonFictionSection = new Section("Non-Fiction");
$nonFictionSection->addBook(new Book("Book 3", "Author 3"));

$library->addSection($fictionSection);
$library->addSection($nonFictionSection);

$totalBooks = $library->countTotalBooks();
echo "Total number of books in the library: " . $totalBooks;
echo '<br>';

$customer1 = new Customer("Customer 1");
$customer2 = new Customer("Customer 2");

$bookToBuy = $fictionSection->books[0]; // Assuming you want to buy the first book in the fiction section.

$customer1->buyBook($bookToBuy, $library);
echo "<br>";
// $customer2->buyBook($bookToBuy, $library);
