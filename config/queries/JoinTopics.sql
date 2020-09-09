SELECT topics.name, topics.description, topics.created, users.username
FROM topics
JOIN users ON topics.user_id = users.id
JOIN subthreads ON topics.subthread_id = subthreads.id
WHERE topics.subthread_id = :subthreadid
ORDER BY
topics.created;