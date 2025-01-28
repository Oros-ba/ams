<?php

	declare(strict_types=1);

	namespace OCA\AMS\Controller;

	use OCA\AMS\Model\Subject;
	use OCA\AMS\Model\SubjectMapper;
	use OCP\AppFramework\Http;
	use OCP\AppFramework\Http\Attribute\ApiRoute;
	use OCP\AppFramework\Http\Attribute\NoAdminRequired;
	use OCP\AppFramework\Http\DataResponse;
	use OCP\AppFramework\OCSController;
	use OCP\IRequest;

	class ApiController extends OCSController {
	    private $subjectMapper;

	    public function __construct(IRequest $request, SubjectMapper $subjectMapper) {
	        parent::__construct('ams', $request);
	        $this->subjectMapper = $subjectMapper;
	    }

	    #[NoAdminRequired]
	    #[ApiRoute(verb: 'POST', url: '/subjects')]
	    public function create(string $name, string $address): DataResponse {
	        $subject = new Subject();
	        $subject->setName($name);
	        $subject->setAddress($address);
	        $insertedSubject = $this->subjectMapper->insert($subject);
	        return new DataResponse(['message' => 'Subject created', 'id' => $insertedSubject.getId], Http::STATUS_CREATED);
	    }

	    #[NoAdminRequired]
	    #[ApiRoute(verb: 'GET', url: '/subjects/{id}')]
	    public function read(int $id): DataResponse {
	        $subject = $this->subjectMapper->getById($id);
	        return new DataResponse($subject);
	    }

	    #[NoAdminRequired]
	    #[ApiRoute(verb: 'GET', url: '/subjects')]
	    public function readAll(): DataResponse {
	        $subjects = $this->subjectMapper->findAll();
	        return new DataResponse($subjects);
	    }

	    #[NoAdminRequired]
	    #[ApiRoute(verb: 'PUT', url: '/subjects/{id}')]
	    public function update(int $id, string $name, string $address): DataResponse {
	        $subject = $this->subjectMapper->getById($id);
	        $subject->setName($name);
	        $subject->setAddress($address);
	        $this->subjectMapper->update($subject);
	        return new DataResponse(['message' => 'Subject updated']);
	    }

	    #[NoAdminRequired]
	    #[ApiRoute(verb: 'DELETE', url: '/subjects/{id}')]
	    public function delete(int $id): DataResponse {
	        $this->subjectMapper->delete($id);
	        return new DataResponse(['message' => 'Subject deleted']);
	    }
	}
