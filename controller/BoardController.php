<?php
    require_once(ROOT . 'model/Board.php');
    require_once(ROOT . 'validation/BoardValidation.php');

    class BoardController extends Controller
    {
        public $errorMessages;
        public $board;
        public $messages = [
            'passwordFill'  => 'Your password must be ?number digit number',
            'nullPassword'  => "This message can't ?action, because this message has not been set "
                            . "password",
            'wrongPassword' => 'The ?action you entered do not match, Please try again.'
        ];
        
        public function __construct()
        {
            $this->board = new Board();
        }

        public function index($currentPage)
        {   
            $select = [
                'id',
                'title', 
                'message',
                'image',
                'password',
                'created_at'
            ];

            $rowCount = $this->board->showAll()->rowCount();
            $page     = new Pagination(10);

            $this->pagination = $page->generate($currentPage, $rowCount);

            if (check_request_method('POST') && get_post('submit')) {
                $this->create();
            }

            $request = new Request();
            
            $data = [
                'boardList'   => $this->board->showLimit($select, $currentPage, $page->limit),
                'errors'      => $this->errorMessages,
                'formBoard'   => $_POST,
                'requestUrl'  => $request->url,
                'formAction'  => 'create'
            ];

            $this->set($data);
            $this->render('home_content.php');
        }

        public function create()
        {           
            $request = [
                'title'    => get_post('title'),
                'message'  => get_post('message'),
                'image'    => get_file('image'),
                'password' => get_post('password')
            ];
            
            $validate            = new BoardValidation();
            $errorInput          = $validate->validatePost($request);
            $errorImage          = $validate->validateFile('image', [$request['image']]);
            $error               = array_merge($errorInput, $errorImage);
            $this->errorMessages = $error;

            if (empty($error)) {
                if (!is_null($request['image'])) {
                    $fileName = str_replace(' ', '-', strtotime(date('Y-m-d H:i:s'))  
                              . "-" 
                              . $request['image']['name']);
                    move_to_public($request['image'],"images/upload/{$fileName}");
                    $request['image'] = $fileName;
                }
                if (!is_null($request['password'])) {
                    $request['password'] = password_hash($request['password'], PASSWORD_DEFAULT);
                }
                $this->board->insert(array_values($request));
                header('Location: /');
            }
        }

        public function edit($id)
        {
            $submitPass = get_post('password');
            $redirect   = get_post('redirect');

            if (is_null($redirect)) {
                header("Location: /");
            }
            
            $boardData = $this->board->show($id);
            
            $showData = [
                'formBoard'  => $boardData,
                'redirect'   => $redirect,
                'submitPass' => $submitPass,
                'formAction' => 'edit'
            ];

            $editFolder = 'edit/';
            
            $validate   = new BoardValidation();
            $messages   = $this->messages;

            if (is_null($boardData['password'])) {
                $showData['errors'] = [
                    str_replace('?action', 'edit', $messages['nullPassword'])
                ];

                $render = $editFolder . 'edit_not_set.php';
            } else {
                if (password_verify($submitPass, $boardData['password'])) {
                    $render = 'form_board.php';
                } else {
                    $showData['errors'] = [
                        str_replace('?action', 'edit', $messages['wrongPassword'])
                    ];

                    $render = $editFolder . 'edit_wrong.php';
                }
            }

            if (check_request_method('POST') && get_post('update')) {
                $request = [
                    'id'           => $id,
                    'title'        => get_post('title'),
                    'message'      => get_post('message'),
                    'image'        => get_file('image')
                ];

                $errorInput          = $validate->validatePost($request);
                $errorImage          = $validate->validateFile('image', [$request['image']]);
                $error               = array_merge($errorInput, $errorImage);
                $this->errorMessages = $error;

                if (empty($error)) {
                    if (get_post('deleteImage')){
                        delete_file("images/upload/{$boardData['image']}");
                        
                        $request['image'] = NULL;
                    } else {
                        if (!is_null($request['image'])) {
                            delete_file("images/upload/{$boardData['image']}");

                            $fileName = str_replace(' ', '-', strtotime(date('Y-m-d H:i:s')) 
                                    . "-" . $request['image']['name']);

                            move_to_public($request['image'],"images/upload/{$fileName}");
                            
                            $request['image'] = $fileName;
                        } else {
                            $request['image'] = $boardData['image'];
                        }
                    }
                    
                    $this->board->update($request);
                    header("Location: {$redirect}");
                } else {
                    $showData['formBoard']['title']   = get_post('title');
                    $showData['formBoard']['message'] = get_post('message');
                    $showData['errors']               = $this->errorMessages;
                }
            } 

            $this->set($showData);
            $this->render($render);
        }

        public function delete($id)
        {
            $submitPass = get_post('password');
            $redirect   = get_post('redirect');

            if (is_null($redirect)) {
                header("Location: /");
            }

            $boardData = $this->board->show($id);

            $showData = [
                'formBoard'  => $boardData,
                'redirect'   => $redirect,
                'submitPass' => $submitPass
            ];

            $deleteFolder = 'delete/';
            $messages   = $this->messages;

            if (is_null($boardData['password'])) {
                $showData['errors'] = [
                    str_replace('?action', 'delete', $messages['nullPassword'])
                ];

                $render = $deleteFolder . 'delete_not_set.php';
            } else {
                if (password_verify($submitPass, $boardData['password'])) { 
                    $render = $deleteFolder . 'delete_correct.php';
                } else {
                    $showData['errors'] = [
                        str_replace('?action', 'delete', $messages['wrongPassword'])
                    ];

                    $render = $deleteFolder . 'delete_wrong.php';
                } 
            }

            if (check_request_method('POST') && get_post('destroy')) {
                delete_file("/images/upload/{$boardData['image']}");
                $this->board->delete($id);
                header("Location: {$redirect}");
            }

            $this->set($showData);
            $this->render($render);
        }
    }
?>