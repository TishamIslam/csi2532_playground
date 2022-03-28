
-- create
CREATE TABLE author (
  author_id INTEGER PRIMARY KEY,
  author_name VARCHAR(20),
  author_sum_rating INTEGER DEFAULT 0
);

CREATE TABLE book (
  book_id INTEGER PRIMARY KEY,
  book_name VARCHAR(20) NOT NULL,
  author_id INTEGER ,
  amount NUMERIC(7,2) NOT NULL,
  rating INTEGER NOT NULL,
  book_type VARCHAR(25) NOT NULL,
  CONSTRAINT authoridCleEtrangere 
    FOREIGN KEY(author_id) 
    REFERENCES author(author_id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  CONSTRAINT ratingEntreUnDix CHECK (rating > 1 AND rating < 10),
  CONSTRAINT amountPlusQueZero CHECK (rating > 0),
  CONSTRAINT booktypeTypes CHECK 
    (book_type IN ('Fiction-adulte', 
      'Non-fiction-adulte', 'Fiction-jeunesse', 'Non-fiction-jeunesse'
    ) 
  )
);

--function
CREATE FUNCTION calcul_author_sum_rating() RETURNS TRIGGER AS $$
  BEGIN
    UPDATE author 
      SET author_sum_rating = (
        SELECT sum(b.rating)
        FROM book AS b, author AS a
        WHERE a.author_id = b.author_id
      );
    RETURN NEW;
  END;
$$ LANGUAGE plpgsql;  

-- assertion
CREATE ASSERTION auteurs_livres_moins_que_10000 
CHECK ( 
  (SELECT count(*) FROM book) +
  (SELECT count(*) FROM author) < 10000
)

-- trigger
CREATE TRIGGER book_rating
  BEFORE UPDATE ON book
  FOR EACH ROW 
  EXECUTE PROCEDURE check_book_rating();

CREATE TRIGGER update_author_sum_rating
  AFTER UPDATE OF rating ON book
  FOR EACH ROW 
  WHEN (OLD.rating IS DISTINCT FROM NEW.rating)
  EXECUTE FUNCTION calcul_author_sum_rating();


-- insert
INSERT INTO author VALUES (1, 'author');
SELECT * FROM author; 
INSERT INTO book VALUES (0001, 'book 1', 1, 1234.5, 3, 'Fiction-adulte');
INSERT INTO book VALUES (0002, 'book 2', 1, 134, 9, 'Fiction-adulte');
INSERT INTO book VALUES (0003, 'book 3', 1, 4, 6, 'Fiction-adulte');

SELECT * FROM book; 

UPDATE book
SET rating = 2
WHERe book_id = 1;

SELECT * FROM author; 
