<?php
require_once __DIR__ . '/../daos/ReviewDAO.php';

class ReviewService {
    private $dao;

    public function __construct($db) {
        $this->dao = new ReviewDAO($db);
    }

    public function getAllReviews() {
        return $this->dao->getAll();
    }

    public function getReviewById($id) {
        return $this->dao->getById($id);
    }

    public function createReview($data) {
        if (!isset($data['user_id'], $data['product_id'], $data['rating'])) {
            throw new Exception("Missing review fields");
        }
        if ($data['rating'] < 1 || $data['rating'] > 5) {
            throw new Exception("Rating must be between 1 and 5");
        }
        return $this->dao->create($data['user_id'], $data['product_id'], $data['rating'], $data['comment'] ?? '');
    }

    public function updateReview($id, $data) {
        return $this->dao->update($id, $data);
    }

    public function deleteReview($id) {
        return $this->dao->delete($id);
    }
}
